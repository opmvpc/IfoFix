import { clsx } from "clsx";
import { twMerge } from "tailwind-merge";

export function cn(...inputs) {
    return twMerge(clsx(inputs));
}

export function valueUpdater(updaterOrValue, ref) {
    if (typeof updaterOrValue === "function") {
        ref.value = updaterOrValue(ref.value);
    } else {
        ref.value = updaterOrValue;
    }
}

export function formatDate(date) {
    return new Date(date).toLocaleDateString("fr-FR");
}
