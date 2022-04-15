import React from 'react';
import { useState, useEffect } from 'react';
import { useHistory } from 'react-router-dom';

const Logout = () =>{
    let history = useHistory();

    useEffect(() => {
        localStorage.clear(); 
        history.push("/login");
       
    }, []);

    return(
            
        <div>
                
        </div>
    );
}
export default Logout;