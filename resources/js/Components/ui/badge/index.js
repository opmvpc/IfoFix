import { cva } from "class-variance-authority";

export { default as Badge } from "./Badge.vue";

export const badgeVariants = cva(
    "inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2",
    {
        variants: {
            variant: {
                default: "bg-gray-100 text-gray-600",
                primary: "bg-blue-100 text-blue-600",
                secondary: "bg-gray-100 text-gray-600",
                success: "bg-emerald-100 text-emerald-600",
                danger: "bg-red-100 text-red-600",
                warning: "bg-orange-100 text-orange-600",
                info: "bg-blue-100 text-blue-600",
            },
        },
        defaultVariants: {
            variant: "default",
        },
    }
);
