import { createContext, useContext, useEffect, useState } from 'react';
import useSWR from 'swr';
import axios, { AxiosResponse } from 'axios';
import React, { ReactNode } from 'react';

interface BoardProviderContextType {
    board: number[][];
    moves: MoveResponse[];
    status: StatusResponse;
    reload(): void;
}

interface MoveResponse {
    start: number;
    end: number;
}

interface StatusResponse {
    win: boolean;
    draw: boolean;
    side: string;
}

const BoardProviderContext = createContext<
    BoardProviderContextType | undefined
>(undefined);

export function useBoardProvider() {
    const context = useContext(BoardProviderContext);

    if (context === undefined) {
        throw new Error('useBoardProvider must be used within a BoardProvider');
    }

    return context;
}

interface BoardProviderProps {
    children: ReactNode;
}

export const BoardProvider: React.FC<BoardProviderProps> = ({ children }) => {
    const { data: response, mutate: mutateBoard } = useSWR<
        AxiosResponse<number[][]>
    >('/api/board/data', axios.get, { refreshInterval: 3000 });

    const { data: moveResponse, mutate: mutateMoves } = useSWR<
        AxiosResponse<MoveResponse[]>
    >('/api/moves/get', axios.get, { refreshInterval: 3000 });

    const { data: boardStatusResponse } = useSWR<AxiosResponse<StatusResponse>>(
        '/api/board/status',
        axios.get,
        { refreshInterval: 3000 },
    );

    const [boardData, setBoardData] = useState<number[][] | undefined>(
        undefined,
    );

    const [moveData, setMoveData] = useState<MoveResponse[] | undefined>(
        undefined,
    );

    const [boardStatus, setBoardStatus] = useState<StatusResponse | undefined>(
        undefined,
    );

    useEffect(() => {
        setBoardData(response?.data);
    }, [response]);

    useEffect(() => {
        setMoveData(moveResponse?.data);
    }, [moveResponse]);

    useEffect(() => {
        setBoardStatus(boardStatusResponse?.data);
    }, [boardStatusResponse]);

    const reload = () => {
        mutateBoard();
        mutateMoves();
    };

    return (
        <BoardProviderContext.Provider
            value={{
                board: boardData || [],
                moves: moveData || [],
                status: boardStatus || { win: false, draw: false, side: '' },
                reload: reload,
            }}
        >
            <div>{children}</div>
        </BoardProviderContext.Provider>
    );
};
