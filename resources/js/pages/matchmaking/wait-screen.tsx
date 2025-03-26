import { useEffect, useState } from "react";
import useSWR from 'swr'
import axios, { AxiosResponse } from 'axios'
import ChessBoard from "@/components/chessboard";
import { ImageProvider } from "@/providers/ImageProvider";

export default function WaitScreen() {
    let { data: response } = useSWR<AxiosResponse<number>>("/api/current-game", axios.get);
    let [currentGame, setCurrentGame] = useState<number|undefined>(undefined);

    useEffect(() => {
        setCurrentGame(response?.data);
        if(currentGame != undefined) {
            // @ts-ignore
            Window.Echo.private(`Game.${currentGame}`).listen("PlayerJoinedGame", (e) => {
                window.location.href = "/play/human"
            })
        }
    }, [response])

    const backToHome = () => {
        // home page will always be '/' so we don't need to overengineer this.
        window.location.href = "/";
    }

    return (
        <div className="relative min-h-screen flex flex-col items-center justify-center" style={{ backgroundColor: '#312e2b' }}>
            <div className="absolute bg-black opacity-30 w-full h-full z-0" />
            <div className="flex-grow flex items-center justify-center">
                <ImageProvider>
                    <ChessBoard size="large" />
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
