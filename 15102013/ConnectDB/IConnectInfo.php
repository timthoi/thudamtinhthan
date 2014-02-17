<?php
interface IConnectInfo{
    const HOST='localhost';
    const UNAME='root';
    const PW='123';
    const DBNAME='codong';
    
    public function doConnect();
}