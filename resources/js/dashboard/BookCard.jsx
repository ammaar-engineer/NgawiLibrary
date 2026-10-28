export default function BookCard({ book, token }) {
    const initials = book.name.trim().slice(0, 2).toUpperCase()

    return (
        <article className="flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-lg hover:shadow-slate-200/70">
            <div className="relative flex h-36 items-center justify-center bg-gradient-to-br from-slate-800 via-slate-900 to-slate-700">
                <span className="text-2xl font-bold tracking-widest text-white/25">{initials}</span>

                <span
                    className={`absolute left-3 top-3 inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[11px] font-medium backdrop-blur ${
                        book.borrowed
                            ? 'bg-white/15 text-white ring-1 ring-inset ring-white/25'
                            : 'bg-emerald-400/20 text-emerald-100 ring-1 ring-inset ring-emerald-300/40'
                    }`}
                >
                    <span className={`h-1.5 w-1.5 rounded-full ${book.borrowed ? 'bg-amber-300' : 'bg-emerald-300'}`} />
                    {book.borrowed ? 'Dipinjam' : 'Tersedia'}
                </span>
            </div>

            <div className="flex flex-1 flex-col gap-3 p-4">
                <div className="space-y-1">
                    <h2 className="line-clamp-2 font-semibold leading-snug text-slate-900" title={book.name}>
                        {book.name}
                    </h2>
                    <p className="text-xs text-slate-500">
                        {book.published_at ? `Terbit ${book.published_at}` : 'Belum terbit'}
                    </p>
                </div>

                <div className="mt-auto">
                    {book.borrowed_by_me ? (
                        <form method="POST" action={`/books/${book.id}/return`}>
                            <input type="hidden" name="_token" value={token} />
                            <button
                                type="submit"
                                className="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:bg-slate-50"
                            >
                                Kembalikan
                            </button>
                        </form>
                    ) : book.borrowed ? (
                        <button
                            type="button"
                            disabled
                            className="w-full cursor-not-allowed rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-400"
                        >
                            Sedang dipinjam
                        </button>
                    ) : (
                        <form method="POST" action={`/books/${book.id}/borrow`}>
                            <input type="hidden" name="_token" value={token} />
                            <button
                                type="submit"
                                className="w-full rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-700 active:scale-[0.99]"
                            >
                                Pinjam
                            </button>
                        </form>
                    )}
                </div>
            </div>
        </article>
    )
}
