import React from 'react';
import {Link} from 'react-router-dom';

const HeaderTest = () =>
{
    return (
            
            /*<div class="topnav">
                <a href="/homepage">Homepage</a> &nbsp;
                {localStorage.getItem('username') == null && 
                <span>
                    <a href="/login">Login</a>
                    <a href="/register">Register</a>
                </span>
                }

                {localStorage.getItem('userType') == 'admin' && 
                    <a href="/adminHomepage">AdminHome</a> 
                }

                {localStorage.getItem('username') != null && 
                <span>
                    <a href="/logout">Logout</a> &nbsp;
                </span>
                }
                
                
            </div> */
            <div class="topnav">
                <Link to="/homepage">Homepage</Link> &nbsp;
                {localStorage.getItem('username') == null && 
                <span>
                    <Link to="/login">Login</Link>
                    <Link to="/register">Register</Link>
                </span>
                }

                {localStorage.getItem('userType') == 'admin' && 
                    <Link to="/adminHomepage">AdminHome</Link> 
                }

                {localStorage.getItem('username') != null && 
                <span>
                    <Link to="/logout">Logout</Link> 
                </span>
                }
                
                
            </div>
                
    );
}
export default HeaderTest;