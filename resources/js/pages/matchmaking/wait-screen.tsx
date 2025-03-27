import { useEffect, useState } from "react";
import useSWR from 'swr'
import axios, { AxiosResponse } from 'axios'
import PreviewChessBoard from "@/components/board/preview-chess-board";
import { ImageProvider } from "@/providers/ImageProvider";
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

export default function WaitScreen() {
    const { data: response } = useSWR<AxiosResponse<number>>("/api/current-game", axios.get);
    const [currentGame, setCurrentGame] = useState<number|undefined>(undefined);

    useEffect(() => {
        setCurrentGame(response?.data);
        if(currentGame != undefined) {
            // @ts-expect-error pusher doesn't exist on window but we want it to
            window.Pusher = Pusher
            const echo = new Echo({
                broadcaster: 'reverb',
                key: import.meta.env.VITE_REVERB_APP_KEY,
                wsHost: import.meta.env.VITE_REVERB_HOST,
                wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
                wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
                forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
                enabledTransports: ['ws', 'wss'],
            });

            // @ts-expect-error e can be anything
            echo.private(`Game.${currentGame}`).listen("PlayerJoinedGame", (e) => {
                window.location.href = "/play/human"
            })
        }
    }, [response, currentGame])

    const backToHome = () => {
        window.location.href = "/";
    }

    return (
        <div className="relative min-h-screen flex flex-col items-center justify-center" style={{ backgroundColor: '#312e2b' }}>
            <div className="absolute bg-black opacity-30 w-full h-full z-0" />
            <div className="flex-grow flex items-center justify-center">
                <ImageProvider>
                    <PreviewChessBoard size="large" />
                </ImageProvider>
            </div>
            <div className="absolute z-10 flex flex-col items-center justify-center">
                <div className="bg-gray-800 p-8 rounded-lg shadow-lg w-96 h-48">
                    <p className="text-center text-2xl font-semibold text-white">Waiting for opponent...</p>
                    <div className="flex items-center justify-center mt-5">
                        <button
                            onClick={backToHome}
                            className="mt-4 px-6 py-3 bg-gray-400 text-black rounded hover:bg-gray-500 transition"
                        >
                            Back to Home
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}
