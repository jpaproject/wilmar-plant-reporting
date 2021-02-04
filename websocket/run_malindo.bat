cd C:\Users\MALINDO-PC\AppData\Roaming\npm\node_modules\node-red
start pm2 start red.js

@echo off
timeout 3
chdir C:\laragon\www\plant-reporting\websocket
start pm2 start start.js

@echo off
timeout 3
chdir C:\laragon\www\plant-reporting\schedule
start pm2 start schedule.js

timeout 5
exit