import { createRoot } from "react-dom/client"
import Register from "./auth/Register"

const el = document.getElementById('app')

createRoot(el).render(
    <Register token={el.dataset.token} errors={JSON.parse(el.dataset.errors)} />
)
