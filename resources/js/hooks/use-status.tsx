import { useEffect, useState } from 'react';
import axios, { AxiosResponse } from 'axios';
import useSWR from 'swr';

interface StatusResponse {
    win: boolean;
    draw: boolean;
    side: string;
}

interface ReturnProps {
    status: StatusResponse;
    refreshStatus(): void;
}

export default function useStatus(): ReturnProps {
    const { data: boardStatusResponse, mutate: refreshStatus } = useSWR<
        AxiosResponse<StatusResponse>
    >('/api/board/status', axios.get, {
        revalidateOnMount: false,
        revalidateOnFocus: false,
        revalidateOnReconnect: false,
    });

    const [boardStatus, setBoardStatus] = useState<StatusResponse | undefined>(
        undefined,
    );

    useEffect(() => {
        setBoardStatus(boardStatusResponse?.data);
    }, [boardStatusResponse]);

    return {
        status: boardStatus || { win: false, draw: false, side: '' },
        refreshStatus: refreshStatus,
    };
}
