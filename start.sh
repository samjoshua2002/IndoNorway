#!/bin/bash

# chmod +x start.sh
# ./start.sh

docker compose start

echo ""
echo "PHP projects running at:"
for folder in ../*/; do
  name=$(basename "$folder")
  echo "http://localhost:8080/$name"
done

echo ""
echo "phpMyAdmin: http://localhost:8081"
echo ""

