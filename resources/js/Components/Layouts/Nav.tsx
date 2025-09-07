import React from 'react';

interface NavItem {
    name: string;
    href: string;
    icon: React.ReactNode;
    isInertia?: boolean;
}

export default function Nav() {

    return (
        <div className="sticky top-0 z-50">
            <nav
                className="flex h-16 items-center gap-x-4 bg-white px-4 shadow-sm ring-1 ring-gray-950/5 md:px-6 lg:px-8">
                {/* Logo */}
                <div className="flex items-center">

                </div>

                {/* Desktop Navigation - Left aligned */}
                <ul className="hidden items-center gap-x-4 lg:flex lg:flex-1 lg:ml-8">

                </ul>


            </nav>

        </div>
    );
}
