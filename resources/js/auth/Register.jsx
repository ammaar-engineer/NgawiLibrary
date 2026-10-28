export default function Register({ token, errors }) {
    return (
        <div className="relative flex min-h-screen items-center justify-center overflow-hidden bg-gray-100 p-4">
            <img
                src="/logo.png"
                alt=""
                aria-hidden="true"
                style={{ transform: 'translate(-50%, -50%) perspective(1200px) rotateX(55deg) rotateY(25deg)' }}
                className="pointer-events-none absolute left-1/2 top-1/2 w-[min(130vw,1100px)] max-w-none opacity-45 mix-blend-multiply blur-md select-none"
            />
            <div
                aria-hidden="true"
                className="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_center,transparent_15%,rgba(0,0,0,0.5)_100%)]"
            />
            <form
                method="POST"
                action="/register"
                className="relative w-full max-w-md space-y-5 rounded-2xl bg-white/95 p-8 shadow-2xl ring-1 ring-black/5 backdrop-blur"
            >
                <div className="flex flex-col items-center gap-3 text-center">
                    <img src="/logo.png" alt="NgawiLibrary" className="h-12 w-12 rounded-xl object-contain" />
                    <div className="space-y-1">
                        <h1 className="text-xl font-semibold tracking-tight text-slate-900">Buat akun baru</h1>
                        <p className="text-sm text-slate-500">Gratis, cukup email dan password.</p>
                    </div>
                </div>

                {errors.length > 0 && (
                    <ul className="space-y-1 rounded-xl bg-red-50 p-3 text-sm text-red-700 ring-1 ring-red-100">
                        {errors.map((error) => <li key={error}>{error}</li>)}
                    </ul>
                )}

                <input type="hidden" name="_token" value={token} />

                <label className="block space-y-1.5 text-sm font-medium text-slate-700">
                    <span>Email</span>
                    <input
                        name="email"
                        type="email"
                        required
                        autoFocus
                        autoComplete="email"
                        placeholder="nama@email.com"
                        className="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-normal text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 focus:outline-none"
                    />
                </label>

                <label className="block space-y-1.5 text-sm font-medium text-slate-700">
                    <span>Password</span>
                    <input
                        name="password"
                        type="password"
                        required
                        minLength={8}
                        autoComplete="new-password"
                        placeholder="Minimal 8 karakter"
                        className="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-normal text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 focus:outline-none"
                    />
                </label>

                <label className="block space-y-1.5 text-sm font-medium text-slate-700">
                    <span>Konfirmasi Password</span>
                    <input
                        name="password_confirmation"
                        type="password"
                        required
                        minLength={8}
                        autoComplete="new-password"
                        placeholder="Ulangi password"
                        className="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-normal text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 focus:outline-none"
                    />
                </label>

                <button
                    type="submit"
                    className="w-full rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 focus:ring-2 focus:ring-slate-900/20 focus:ring-offset-2 focus:outline-none active:scale-[0.99]"
                >
                    Daftar
                </button>

                <p className="border-t border-slate-100 pt-4 text-center text-sm text-slate-500">
                    Sudah punya akun?{' '}
                    <a href="/login" className="font-semibold text-slate-900 underline-offset-4 hover:underline">
                        Masuk
                    </a>
                </p>
            </form>
        </div>
    );
}
