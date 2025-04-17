import { useEffect, useRef } from 'react';
import { deepCompare } from '@/utils/deep-compare';

export const useDeepCompareEffect = (
    callback: () => void,
    dependencies: any[],
) => {
    const previousDepsRef = useRef<any[]>([]);

    useEffect(() => {
        if (!deepCompare(previousDepsRef.current, dependencies)) {
            callback();
        }
        previousDepsRef.current = dependencies;
    }, [callback, dependencies]);
};
