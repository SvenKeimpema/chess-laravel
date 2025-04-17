import { useEffect, useState } from 'react';
import axios, { AxiosResponse } from 'axios';
import useSWR from 'swr';

interface ReturnProps {
    side: 'player1' | 'player2';
}

export default function useCurrentSide(): ReturnProps {
    const { data: currentSideResponse } = useSWR<AxiosResponse<boolean>>(
        '/api/current-side',
        axios.get,
        { refreshInterval: 500 },
    );

    const [currentSide, setCurrentSide] = useState<boolean | undefined>(
        undefined,
    );

    useEffect(() => {
        setCurrentSide(currentSideResponse?.data);
    }, [currentSideResponse]);
    return {
        side: currentSide ? 'player1' : 'player2',
    };
}
