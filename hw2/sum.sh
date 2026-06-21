#!/bin/bash

if [ $# -ne 2 ]; then
    echo "Usage: $0 <number1> <number2>"
    exit 1
fi

number_regex='^-?[0-9]+([.][0-9]+)?$'
for number in "$@"; do
    if ! echo "$number" | grep -Eq "$number_regex"; then
        echo "Error: argument '$number' is not a valid number"
        exit 1
    fi
done

sum=$(awk "BEGIN {print ($1) + ($2)}")
echo $sum
