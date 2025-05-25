import React, { PropsWithChildren } from 'react';
import { Link, usePage } from '@inertiajs/react';
import store from '@routes/store';
import filamentStore from '@routes/filament/store';
import Nav from './Nav';
import { Toaster } from 'react-hot-toast';

interface LayoutProps extends PropsWithChildren { }

export default function Layout({ children }: LayoutProps) {
    const { url } = usePage();

    const isActive = (path: string) => {
        return url.startsWith(path);
    };

    const navigation = [
        { name: 'Store', href: store.index.get().url, isInertia: false },
        { name: 'Cart', href: filamentStore.pages.cartIndex.get().url, isInertia: false },
        { name: 'Budget Estimate', href: filamentStore.pages.budgetEstimate.get().url, isInertia: false },
        { name: 'Profile', href: filamentStore.pages.customerProfile.get().url, isInertia: false },
    ];

    return (
        <div className="min-h-screen bg-gray-100">
            <Toaster position="top-right" />
            <Nav />
            <main>{children}</main>
        </div>
    );
} 