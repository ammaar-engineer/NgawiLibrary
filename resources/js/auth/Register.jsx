export default function Register({ token, errors }) {
    return (
        <div className="flex min-h-screen items-center justify-center bg-gray-100 p-4">
            <form method="POST" action="/register" className="w-full max-w-sm space-y-4 rounded-lg bg-white p-6 shadow">
                <h1 className="text-xl font-semibold">Daftar</h1>

                {errors.length > 0 && (
                    <ul className="list-disc space-y-1 rounded bg-red-50 p-3 pl-6 text-sm text-red-700">
                        {errors.map((error) => <li key={error}>{error}</li>)}
                    </ul>
                )}

                <input type="hidden" name="_token" value={token} />

                <label className="block text-sm">
                    Email
                    <input
                        name="email"
                        type="email"
                        required
                        autoFocus
                        className="mt-1 w-full rounded border px-3 py-2"
                    />
                </label>

                <label className="block text-sm">
                    Password
                    <input
                        name="password"
                        type="password"
                        required
                        minLength={8}
                        className="mt-1 w-full rounded border px-3 py-2"
                    />
                </label>

                <label className="block text-sm">
                    Konfirmasi Password
                    <input
                        name="password_confirmation"
                        type="password"
                        required
                        minLength={8}
                        className="mt-1 w-full rounded border px-3 py-2"
                    />
                </label>

                <button type="submit" className="w-full rounded bg-black px-4 py-2 text-white">
                    Daftar
                </button>

                <p className="text-center text-sm">
                    Sudah punya akun? <a href="/login" className="underline">Masuk</a>
                </p>
            </form>
        </div>
    );
}
