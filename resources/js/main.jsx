import {QueryClient, QueryClientProvider} from '@tanstack/react-query';
import React, {useEffect, useState} from 'react';
import ReactDOM from 'react-dom/client';

// Grab all .tsx under filament (including nested)
const modules = import.meta.glob('./filament/**/*.tsx');

const App = ({componentName, props}) => {
    const [ComponentToRender, setComponentToRender] = useState(null);
    const [notFound, setNotFound] = useState(false);

    useEffect(() => {
        let isMounted = true;
        setNotFound(false);
        setComponentToRender(null);

        const load = async () => {
            // normalize keys like "ui/Button" from paths
            const entry = Object.entries(modules).find(([path]) => {
                // e.g. "./filament/ui/Button.tsx" → "ui/Button"
                const relative = path.replace(/^\.\/filament\//, '').replace(/\.\w+$/, '');
                return relative === componentName;
            });

            if (!entry) {
                if (isMounted) {
                    setNotFound(true);
                }
                return;
            }

            const [, importer] = entry;
            const module = await importer();

            if (isMounted) {
                setComponentToRender(() => module.default);
            }
        };

        void load();

        return () => {
            isMounted = false;
        };
    }, [componentName]);

    if (notFound) {
        return <div>Component "{componentName}" not found.</div>;
    }

    if (!ComponentToRender) {
        return null; // nothing until loaded
    }

    return <ComponentToRender {...props} />;
};
const queryClient = new QueryClient();

document.addEventListener('livewire:navigated', () => {
    const rootElement = document.getElementById('filament');

    if (!rootElement) return;

    const root = ReactDOM.createRoot(rootElement);

    const componentName = rootElement.getAttribute('data-component') ?? '';
    const propsAttr = rootElement.getAttribute('data-props') ?? '{}';
    let parsedProps;
    try {
        parsedProps = JSON.parse(propsAttr);
    } catch {
        parsedProps = {};
    }

    root.render(
        <QueryClientProvider client={queryClient}>
            <App componentName={componentName} props={parsedProps}/>
        </QueryClientProvider>,
    );
});

