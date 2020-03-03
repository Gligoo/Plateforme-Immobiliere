*   Lançer le server  -> php -S 127.0.0.1:8001 -t public
*   kill server -> kill -9 $(lsof -i tcp:8001 -t)