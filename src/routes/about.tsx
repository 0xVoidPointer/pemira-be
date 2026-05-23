import { createFileRoute } from '@tanstack/react-router';
import { useEffect, useState } from 'react';
import axios from 'axios';

export const Route = createFileRoute('/about')({
    component: AboutPage,
});

function AboutPage() {
    const [msg, setMsg] = useState<string>('loading...');

    useEffect(() => {
        axios
            .get('/api/test')
            .then((res) => setMsg(res.data.message))
            .catch((err) => setMsg(`error: ${err.message}`));
    }, []);

    return (
        <div>
            <h1 className="text-2xl font-bold">About</h1>
            <p>Halaman about Pemira.</p>
            <p>API: {msg}</p>
        </div>
    );
}
