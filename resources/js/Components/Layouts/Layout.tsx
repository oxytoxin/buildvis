import {PropsWithChildren} from 'react';
import Nav from './Nav';
import {Toaster} from 'react-hot-toast';

interface LayoutProps extends PropsWithChildren {
}

export default function Layout({children}: LayoutProps) {

    return (
        <div className="min-h-screen bg-gray-100">
            <Toaster position="top-right"/>
            <Nav/>
            <main>{children}</main>
        </div>
    );
}
