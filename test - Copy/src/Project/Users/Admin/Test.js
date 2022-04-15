import { useState, useEffect } from "react";
import axios from 'axios';

function AdminHomepage() {

    useEffect(() => {
            axios.get("http://127.0.0.1:8000/api/admin/homepage").then((resp)=>{
            console.log(localStorage.getItem('authToken'));
            console.log(localStorage.getItem('userType'));
            console.log(resp.data);
        },(err)=>{
            console.log(localStorage.getItem('authToken') + "error");
            console.log(localStorage.getItem('userType') + "error");

        });
        
    }, );

    return(
        <div>
            <h1>Admin home</h1>
        </div>
    );
}
export default AdminHomepage;