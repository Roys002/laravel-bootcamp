// Utility function for shadcn-vue components
// See: https://ui.shadcn.com/docs/components/utils

export function cn(...inputs: Array<string | undefined | null | false>): string {
  return inputs.filter(Boolean).join(' ');
}
