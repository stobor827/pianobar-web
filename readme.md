# pianobar-web

a Node.js site for controlling a headless instance of pianobar, optimized for use as a pwa on ios.

## Installation

 * clone/download to a useful dir.
 * use npm in above dir to install dependencies
    ```bash
    npm install
    ```
 * modify pianobar config to use eventcmd.sh<br> 
    Default location is ~/.config/pianobar/config
    ```
    user = 
    password = 

    autostart_station = 

    event_command = {path to pianobar-web}/eventcmd.sh
    ```
 * create symlink to pianbar's ctl pipe.
    ```bash
    ln -s ~/.config/pianobar/ctl {path to pianobar-web}/ctl
    ```
  
   default location is ~/.config/pianobar/ctl, may need to create it if missing
   ```bash
   mkfifo ~/.config/pianobar/ctl
   ```

 * [optional] setup proxy to node server
   Apache:
    ```
    ProxyPass "/pianobarweb" "http://localhost:8006"
    ```

 * start pianobar<br>
   [optional] use this config file for systemd
   ```
    #/etc/systemd/system/pianobar.service
    [Unit]
    Description=pianobar
    After=network.target

    [Service]
    Type=simple
    Restart=always
    User=
    ExecStart=pianobar

    [Install]
    WantedBy=multi-user.target

 * start pianobar-web<br>
    ```bash
    node app.js
    ```
   [optional] use this config file for systemd
   ```
    #/etc/systemd/system/pianobar-web.service
    [Unit]
    Description=node_pb
    After=network.target

    [Service]
    Type=simple
    Restart=always
    User=
    ExecStart=node /var/www/node_pb/app.js

    [Install]
    WantedBy=multi-user.target
    ```
* navigate to site<br>
  if on ios/safari, use sharing button to save to homescreen.