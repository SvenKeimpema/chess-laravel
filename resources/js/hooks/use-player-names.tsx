import { useEffect, useState } from 'react';
import axios, { AxiosResponse } from 'axios';
import useSWR from 'swr';

interface PlayerNamesResponse {
    names: string[];
}

interface ReturnProps {
    names: string[];
}

export default function usePlayerNames(): ReturnProps {
    const { data: playerNamesResponse } = useSWR<
        AxiosResponse<PlayerNamesResponse>
    >('/api/game/names', axios.get, {});

    const [playersNames, setPlayersNames] = useState<
        PlayerNamesResponse | undefined
    >(undefined);

    useEffect(() => {
        setPlayersNames(playerNamesResponse?.data);
    }, [playerNamesResponse]);

    return {
        names: playersNames?.names || ['', ''],
    };
}
