import { Link, Outlet, createRootRoute } from '@tanstack/react-router';

export const Route = createRootRoute({
    component: RootLayout,
});

function RootLayout() {
    return (
        <>
            <nav className="flex gap-4 p-4 border-b">
                <Link to="/home" className="[&.active]:font-bold">
                    Home
                </Link>
                <Link to="/about" className="[&.active]:font-bold">
                    About
                </Link>
            </nav>
            <main className="p-4">
                <Outlet />
            </main>
        </>
    );
}
