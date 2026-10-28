import { createRoot } from "react-dom/client"
import Login from "./auth/Login"

const el = document.getElementById('app')

createRoot(el).render(
    <Login token={el.dataset.token} email={el.dataset.email} errors={JSON.parse(el.dataset.errors)} />
)
