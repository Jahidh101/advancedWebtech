import React from 'react';
import {Link} from 'react-router-dom';

const HeaderTest = () =>
{
    return (
            
            <div class="topnav">
                <Link to="/homepage">Homepage</Link> &nbsp;
                <Link to="/login">Login</Link> &nbsp;
                <Link to="/register">Register</Link> &nbsp;
                <a href="/adminHomepage">AdminHome</a> &nbsp;
            </div> 
                
    );
}
export default HeaderTest;