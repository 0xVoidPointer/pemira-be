import './bootstrap';

import { RouterProvider } from '@tanstack/react-router';
import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';

import { getRouter } from '../../src/router';

const router = getRouter();

declare module '@tanstack/react-router' {
    interface Register {
        router: ReturnType<typeof getRouter>;
    }
}

const rootEl = document.getElementById('root');
if (rootEl) {
    createRoot(rootEl).render(
        <StrictMode>
            <RouterProvider router={router} />
        </StrictMode>,
    );
}
