import BookCard from "./BookCard"

function Icon({ path }) {
    return (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
            <path d={path} />
        </svg>
    )
}

const BookIcon = "M4 19.5A2.5 2.5 0 0 1 6.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"
const BookmarkIcon = "M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"
const LogoutIcon = "M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"

const menus = [
    { key: 'all', href: '/dashboard', label: 'All books', icon: BookIcon },
    { key: 'mine', href: '/dashboard/my-books', label: 'Your books', icon: BookmarkIcon },
]

export default function Dashboard({ menu, email, token, books, errors }) {
    const current = menus.find((m) => m.key === menu) ?? menus[0]

    return (
        <div className="flex min-h-screen bg-slate-50 text-slate-900">
            <aside className="sticky top-0 flex h-screen w-64 shrink-0 flex-col border-r border-slate-200 bg-white">
                <div className="flex items-center gap-2.5 px-5 py-5">
                    <img src="/logo.png" alt="NgawiLibrary" className="h-11 w-11 rounded-xl object-contain" />
                    <div className="leading-tight">
                        <p className="text-sm font-semibold">NgawiLibrary</p>
                        <p className="text-xs text-slate-400">Perpustakaan digital</p>
                    </div>
                </div>

                <nav className="flex flex-1 flex-col gap-1 px-3">
                    <p className="px-3 pb-2 pt-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                        Koleksi
                    </p>

                    {menus.map(({ key, href, label, icon }) => {
                        const active = key === current.key

                        return (
                            <a
                                key={key}
                                href={href}
                                className={`flex items-center gap-3 rounded-lg px-3 py-2 text-sm transition ${
                                    active
                                        ? 'bg-slate-900 font-medium text-white shadow-sm'
                                        : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'
                                }`}
                            >
                                <Icon path={icon} />
                                {label}
                            </a>
                        )
                    })}
                </nav>

                <div className="border-t border-slate-200 p-3">
                    <div className="flex items-center gap-3 rounded-lg px-2 py-2">
                        <span className="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 text-xs font-semibold uppercase text-slate-600">
                            {email.slice(0, 2)}
                        </span>
                        <p className="min-w-0 flex-1 truncate text-xs text-slate-500" title={email}>
                            {email}
                        </p>
                    </div>

                    <form method="POST" action="/logout">
                        <input type="hidden" name="_token" value={token} />
                        <button
                            type="submit"
                            className="mt-1 flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition hover:bg-red-50 hover:text-red-600"
                        >
                            <Icon path={LogoutIcon} />
                            Keluar
                        </button>
                    </form>
                </div>
            </aside>

            <main className="flex-1">
                <header className="border-b border-slate-200 bg-white/80 px-8 py-6 backdrop-blur">
                    <h1 className="text-2xl font-semibold tracking-tight">{current.label}</h1>
                    <p className="mt-1 text-sm text-slate-500">
                        {menu === 'mine'
                            ? 'Buku yang sedang kamu pinjam.'
                            : 'Jelajahi koleksi dan pinjam buku yang kamu butuhkan.'}
                    </p>
                </header>

                <div className="space-y-6 px-8 py-8">
                    {errors.length > 0 && (
                        <div className="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {errors.map((error) => <p key={error}>{error}</p>)}
                        </div>
                    )}

                    <p className="text-sm text-slate-500">
                        <span className="font-medium text-slate-900">{books.length}</span> buku
                    </p>

                    {books.length === 0 ? (
                        <div className="flex flex-col items-center justify-center gap-2 rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                            <span className="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                <Icon path={BookIcon} />
                            </span>
                            <p className="text-sm font-medium text-slate-700">Belum ada buku</p>
                            <p className="text-sm text-slate-500">
                                {menu === 'mine'
                                    ? 'Kamu belum meminjam buku apa pun.'
                                    : 'Koleksi perpustakaan masih kosong.'}
                            </p>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4">
                            {books.map((book) => (
                                <BookCard key={book.id} book={book} token={token} />
                            ))}
                        </div>
                    )}
                </div>
            </main>
        </div>
    )
}
