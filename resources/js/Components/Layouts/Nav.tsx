import React, {useState} from 'react';
import {Link, usePage} from '@inertiajs/react';
import store from '@routes/store';

interface NavItem {
    name: string;
    href: string;
    icon: React.ReactNode;
    isInertia?: boolean;
}

export default function Nav() {
    const [isDropdownOpen, setIsDropdownOpen] = useState(false);
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
    const {url} = usePage();

    const isActive = (path: string) => url.startsWith(path);

    const navigation: NavItem[] = [];

    const NavLink = ({item, isItemActive, className = ''}: {
        item: NavItem;
        isItemActive: boolean;
        className?: string
    }) => {
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
            <nav
                className="flex h-16 items-center gap-x-4 bg-white px-4 shadow-sm ring-1 ring-gray-950/5 md:px-6 lg:px-8">
                {/* Logo */}
                <div className="flex items-center">
                    <Link href={store.index.get().url}
                          className="text-xl font-bold leading-5 tracking-tight text-gray-950">
                        BuildVis
                    </Link>
                </div>

                {/* Desktop Navigation - Left aligned */}
                <ul className="hidden items-center gap-x-4 lg:flex lg:flex-1 lg:ml-8">
                    {navigation.map((item) => (
                        <li key={item.name}>
                            <NavLink item={item} isItemActive={isActive(item.href)}/>
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
                        <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" strokeWidth="1.5"
                             stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    ) : (
                        <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" strokeWidth="1.5"
                             stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round"
                                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
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
                            <div
                                className="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
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
                                            <svg className="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 20 20" fill="currentColor">
                                                <path fillRule="evenodd"
                                                      d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z"
                                                      clipRule="evenodd"/>
                                                <path fillRule="evenodd"
                                                      d="M19 10a.75.75 0 0 0-.75-.75H8.704l1.048-.943a.75.75 0 1 0-1.004-1.114l-2.5 2.25a.75.75 0 0 0 0 1.114l2.5 2.25a.75.75 0 1 0 1.004-1.114l-1.048-.943h9.546A.75.75 0 0 0 19 10Z"
                                                      clipRule="evenodd"/>
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
