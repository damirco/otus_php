#!/bin/bash

FILE_NAME=$2
ROWS=${1:-3}

if ! expr "$ROWS" + 0 >/dev/null 2>&1; then
  echo "Usage: $0 [<number_of_lines> [<file_name>]]" >&2
  exit 1
fi

if [ "$ROWS" -le 0 ]; then
  echo "Error: number of lines must be greater than 0." >&2
  echo "Usage: $0 [<number_of_lines> [<file_name>]]" >&2
  exit 1
fi

if [ ! -z "$FILE_NAME" ] && [ ! -f "$FILE_NAME" ]; then
  echo "Error: file '$FILE_NAME' not found." >&2
  echo "Usage: $0 [<number_of_lines> [<file_name>]]" >&2
  exit 1
fi

awk 'NR > 1 && NF {print $3}' ${FILE_NAME:--} |\
sort | uniq -ci | sort -nr | head -n "$ROWS" |\
awk '{print $2 " (" $1 ")"}'
