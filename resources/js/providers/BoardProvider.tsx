import { createContext, useContext, useEffect, useState } from 'react';
import useSWR from 'swr';
import axios, { AxiosResponse } from 'axios';
import React, { ReactNode } from 'react';

interface BoardProviderContextType {
    board: number[][];
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
    const [boardData, setBoardData] = useState<number[][] | undefined>(
        undefined,
    );

    useEffect(() => {
        setBoardData(response?.data);
    }, [response]);

    return (
        <BoardProviderContext.Provider
            value={{
                board: boardData || [],
            }}
        >
            <div>{children}</div>
        </BoardProviderContext.Provider>
    );
};
