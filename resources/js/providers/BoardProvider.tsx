import { createContext, useContext, useEffect, useState } from 'react';
import useSWR from 'swr';
import axios, { AxiosResponse } from 'axios';
import React, { ReactNode } from 'react';

interface BoardProviderContextType {
    board: number[][];
    moves: MoveResponse[];
}

interface MoveResponse {
    start: number;
    end: number;
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
    const { data: response } = useSWR<AxiosResponse<number[][]>>(
        '/api/board/data',
        axios.get,
    );

    const { data: moveResponse } = useSWR<AxiosResponse<MoveResponse[]>>(
        '/api/moves/get',
        axios.get,
    );

    const [boardData, setBoardData] = useState<number[][] | undefined>(
        undefined,
    );

    const [moveData, setMoveData] = useState<MoveResponse[] | undefined>(
        undefined,
    );

    useEffect(() => {
        setBoardData(response?.data);
    }, [response]);

    useEffect(() => {
        setMoveData(moveResponse?.data);
    }, [moveResponse]);

    return (
        <BoardProviderContext.Provider
            value={{
                board: boardData || [],
                moves: moveData || [],
            }}
        >
            <div>{children}</div>
        </BoardProviderContext.Provider>
    );
};
