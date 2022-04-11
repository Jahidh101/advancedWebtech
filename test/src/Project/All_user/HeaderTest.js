import React from 'react';
import {Link} from 'react-router-dom';

const HeaderTest = () =>
{
    return (
        <html lang="en">
            <head>  
            <link rel="stylesheet" href="topTemp/css/style.css"/>

            </head>
            <body>
            <div class="topnav">
                <Link to="/">Homepage</Link> &nbsp;
                <Link to="/login">Login</Link> &nbsp;
                <Link to="/register">Register</Link> &nbsp;
            </div> 
                
            </body>
        </html>
    );
}
export default HeaderTest;