import { createRoot } from "react-dom/client"
import Dashboard from "./dashboard/Dashboard"

const el = document.getElementById('app')

createRoot(el).render(
    <Dashboard
        menu={el.dataset.menu}
        email={el.dataset.email}
        token={el.dataset.token}
        books={JSON.parse(el.dataset.books)}
        errors={JSON.parse(el.dataset.errors)}
    />
)
