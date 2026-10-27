#!/bin/sh

set -eu

if [ "$#" -ne 1 ] || [ -z "${1-}" ]; then
    printf 'Usage: composer ai:publish -- <agent>\n' >&2
    exit 1
fi

root="$(CDPATH= cd -P "$(dirname "$0")/.." && pwd)"
adapter="$1"
case "$adapter" in
    .|..|*/*)
        printf 'Expected an adapter directory name: %s\n' "$adapter" >&2
        exit 1
        ;;
esac
source_dir="$root/ai/adapters/$adapter"

if [ ! -d "$source_dir" ]; then
    printf 'No adapter directory: %s\n' "$adapter" >&2
    exit 1
fi

# Stage the complete adapter, including hidden files and linked shared content,
# before replacing its project-root entries.
temporary="$(mktemp -d)"
trap 'rm -rf "$temporary"' 0
staging="$temporary/adapter"
mkdir "$staging"
cp -RL "$source_dir/." "$staging/"
find "$staging" -type f -name .gitkeep -exec rm -f {} +

# Compose the always-read baseline once, in a stable order.
composed="$temporary/instructions.md"
cat "$root/ai/instructions.md" > "$composed"
find "$root/ai/guidelines" -type f -name '*.md' | LC_ALL=C sort > "$temporary/guidelines"
while IFS= read -r guideline; do
    printf '\n\n---\n\n<!-- %s -->\n\n' "${guideline#"$root"/}" >> "$composed"
    cat "$guideline" >> "$composed"
    printf '\n' >> "$composed"
done < "$temporary/guidelines"

# Shared entry points are adapter symlinks directly to ai/instructions.md.
find "$source_dir" -type l > "$temporary/links"
while IFS= read -r entry; do
    [ -f "$entry" ] || continue
    link="$(readlink "$entry")"
    case "$link" in
        /*) resolved="$link" ;;
        *) resolved="$(dirname "$entry")/$link" ;;
    esac
    resolved="$(CDPATH= cd -P "$(dirname "$resolved")" && pwd)/$(basename "$resolved")"
    if [ "$resolved" = "$root/ai/instructions.md" ]; then
        cp "$composed" "$staging/${entry#"$source_dir"/}"
    fi
done < "$temporary/links"

for source in "$staging"/* "$staging"/.[!.]* "$staging"/..?*; do
    [ -e "$source" ] || [ -L "$source" ] || continue
    target="$root/$(basename "$source")"
    rm -rf "$target"
    cp -R "$source" "$target"
done
