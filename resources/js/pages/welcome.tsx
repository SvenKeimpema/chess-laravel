import Header from "@/components/welcome-page/welcome-header";
import Sidebar from "@/components/welcome-page/welcome-sidebar";
import MainContent from "@/components/welcome-page/welcome-content";
import Footer from "@/components/welcome-page/welcome-footer";
import useSWR from 'swr'
import axios, { AxiosResponse } from 'axios'
import { useEffect, useState } from "react";

interface loggedInResponse {
    loggedIn: boolean
}

export default function Welcome() {
    let { data: response } = useSWR<AxiosResponse<loggedInResponse>>("/api/user/loggedIn", axios.post, {refreshInterval: 500});
    let [loggedIn, setLoggedIn] = useState<boolean | undefined>(undefined);

    useEffect(() => {
        setLoggedIn(response?.data.loggedIn);
    }, [response])

    return (
        <div className="min-h-screen flex flex-col bg-chess-light">
            <Header isLoggedIn={loggedIn || false} />
                <div className="flex flex-1">
                    <Sidebar />
                    <MainContent />
                </div>
            <Footer />
        </div>
    );
}
