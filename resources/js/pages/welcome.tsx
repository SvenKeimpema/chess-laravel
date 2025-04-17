import Profile from '@/components/user/profile';
import MainContent from '@/components/welcome-page/welcome-content';
import { ImageProvider } from '@/providers/ImageProvider';

export default function Welcome() {
    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-100">
            <Profile />
            <ImageProvider>
                <div className="flex items-center justify-center">
                    <MainContent />
                </div>
            </ImageProvider>
        </div>
    );
}
