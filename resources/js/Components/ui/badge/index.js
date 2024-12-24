import { cva } from "class-variance-authority";

export { default as Badge } from "./Badge.vue";

export const badgeVariants = cva(
    "inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2",
    {
        variants: {
            variant: {
                default: "badge-default",
                primary: "badge-primary",
                secondary: "badge-secondary",
                success: "badge-success",
                danger: "badge-danger",
                warning: "badge-warning",
                info: "badge-info",
            },
        },
        defaultVariants: {
            variant: "default",
        },
    }
);
