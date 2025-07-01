import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import store from '@routes/store';
import filamentStore from '@routes/filament/store';

interface NavItem {
    name: string;
    href: string;
    icon: React.ReactNode;
    isInertia?: boolean;
}

export default function Nav() {
    const [isDropdownOpen, setIsDropdownOpen] = useState(false);
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
    const { url } = usePage();

    const isActive = (path: string) => url.startsWith(path);

    const navigation: NavItem[] = [
        {
            name: 'Store',
            href: store.index.get().url,
            icon: (
                <svg className="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" aria-hidden="true">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                </svg>
            ),
            isInertia: true
        },
        {
            name: 'Cart',
            href: filamentStore.pages.cartIndex.get().url,
            icon: (
                <svg className="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" aria-hidden="true">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
            ),
            isInertia: false
        },
        {
            name: 'Budget Estimate',
            href: filamentStore.pages.budgetEstimate.get().url,
            icon: (
                <svg className="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" aria-hidden="true">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
            ),
            isInertia: false
        },
        {
            name: 'Profile',
            href: filamentStore.pages.customerProfile.get().url,
            icon: (
                <svg className="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" aria-hidden="true">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            ),
            isInertia: false
        },
    ];

    const NavLink = ({ item, isItemActive, className = '' }: { item: NavItem; isItemActive: boolean; className?: string }) => {
        const LinkComponent = item.isInertia ? Link : 'a';
        return (
            <LinkComponent
                href={item.href}
                className={`flex items-center gap-x-2 rounded-lg px-3 py-2 outline-none transition duration-75 hover:bg-gray-50 focus-visible:bg-gray-50 ${isItemActive ? 'bg-gray-50' : ''} ${className}`}
                onClick={() => setIsMobileMenuOpen(false)}
            >
                {React.cloneElement(item.icon as React.ReactElement, {
                    className: `h-5 w-5 ${isItemActive ? 'text-primary-600' : 'text-gray-400'}`
                })}
                <span className={`text-sm font-medium ${isItemActive ? 'text-primary-600' : 'text-gray-700'}`}>
                    {item.name}
                </span>
            </LinkComponent>
        );
    };

    return (
        <div className="sticky top-0 z-50">
            <nav className="flex h-16 items-center gap-x-4 bg-white px-4 shadow-sm ring-1 ring-gray-950/5 md:px-6 lg:px-8">
                {/* Logo */}
                <div className="flex items-center">
                    <Link href={store.index.get().url} className="text-xl font-bold leading-5 tracking-tight text-gray-950">
                        BuildVis
                    </Link>
                </div>

                {/* Desktop Navigation - Left aligned */}
                <ul className="hidden items-center gap-x-4 lg:flex lg:flex-1 lg:ml-8">
                    {navigation.map((item) => (
                        <li key={item.name}>
                            <NavLink item={item} isItemActive={isActive(item.href)} />
                        </li>
                    ))}
                </ul>

                {/* Mobile menu button */}
                <button
                    type="button"
                    className="lg:hidden rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500"
                    onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
                >
                    <span className="sr-only">Open menu</span>
                    {isMobileMenuOpen ? (
                        <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    ) : (
                        <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    )}
                </button>

                {/* User Menu */}
                <div className="flex items-center gap-x-4">
                    <div className="relative">
                        <button
                            onClick={() => setIsDropdownOpen(!isDropdownOpen)}
                            className="shrink-0"
                            aria-label="User menu"
                            type="button"
                        >
                            <img
                                className="fi-avatar object-cover object-center fi-circular rounded-full h-8 w-8"
                                src="https://ui-avatars.com/api/?name=M+J+L+A+C&color=FFFFFF&background=09090b"
                                alt="Avatar"
                            />
                        </button>

                        {isDropdownOpen && (
                            <div className="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <div className="py-1">
                                    <form action="/store/logout" method="post">
                                        <input
                                            type="hidden"
                                            name="_token"
                                            value={document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''}
                                        />
                                        <button
                                            type="submit"
                                            className="flex w-full items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        >
                                            <svg className="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fillRule="evenodd" d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z" clipRule="evenodd" />
                                                <path fillRule="evenodd" d="M19 10a.75.75 0 0 0-.75-.75H8.704l1.048-.943a.75.75 0 1 0-1.004-1.114l-2.5 2.25a.75.75 0 0 0 0 1.114l2.5 2.25a.75.75 0 1 0 1.004-1.114l-1.048-.943h9.546A.75.75 0 0 0 19 10Z" clipRule="evenodd" />
                                            </svg>
                                            <span>Sign out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            </nav>

            {/* Mobile Navigation Menu */}
            {isMobileMenuOpen && (
                <div className="lg:hidden">
                    <div className="space-y-1 px-2 pb-3 pt-2 bg-white shadow-lg">
                        {navigation.map((item) => (
                            <NavLink
                                key={item.name}
                                item={item}
                                isItemActive={isActive(item.href)}
                                className="block w-full"
                            />
                        ))}
                    </div>
                </div>
            )}
        </div>
    );
}