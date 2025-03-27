import { createContext, useContext, useEffect, useState } from "react"
import useSWR from "swr";
import axios, { AxiosResponse } from "axios";
import React, { ReactNode } from 'react';

interface ImageProviderContextType {
    images: { [key: number]: string }
}

const ImageProviderContext = createContext<ImageProviderContextType | undefined>(undefined)

export function useImageProvider() {
    const context = useContext(ImageProviderContext);

    if(context === undefined) {
        throw new Error("useImageProvider must be used within a ImageProvider");
    }

    return context;
}

interface ImageProviderProps {
    children: ReactNode;
}

export const ImageProvider: React.FC<ImageProviderProps> = ({ children }) => {
    const {data: response} = useSWR<AxiosResponse<{ [key: number]: string}>>("/api/piece/images", axios.post);
    const [imageBlobs, setImageBlobs] = useState<{ [key: number]: string } | undefined>({});

    useEffect(() => {        
        setImageBlobs(response?.data);
    }, [response])

    return (
        <ImageProviderContext.Provider
            value={{
                images: imageBlobs || {}
            }}
        >
            <div>
                {children}
            </div>
        </ImageProviderContext.Provider>
    )
}