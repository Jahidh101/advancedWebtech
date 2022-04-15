import { useState, useEffect } from "react";
import axios from 'axios';
import Header from '../../All_user/Header'

function AdminHomepage() {

    const [data, setData] = useState({});
    const [errorAuth, setErrorAuth] = useState('');

    useEffect(() => {
            axios.get("http://127.0.0.1:8000/api/admin/homepage").then((resp)=>{
            console.log(resp.data);
            setErrorAuth(resp.data.unAuth);
            setData(resp.data);
        },(err)=>{

        });
        
    }, []);

    return(
        <div>
            <Header/>
            <h4>{localStorage.getItem('authToken')}</h4>
            <h4>{localStorage.getItem('username')}</h4>
            <h4>{localStorage.getItem('userType')}</h4>
            <h2>{errorAuth}</h2>
            <h1>Admin home</h1>
            <h3>Total verified users :</h3>
            <h2>{data.allVerifiedUsers}</h2>

            <h3>Total verified doctors :</h3>
            <h2>{data.verifiedDoctors}</h2>

            <h3>Total verified patients :</h3>
            <h2>{data.verifiedPatients}</h2>

            <h3>Total verified sellers :</h3>
            <h2>{data.verifiedSellers}</h2>

            <h3>Total verified deliveryman :</h3>
            <h2>{data.verifiedDelivarymen}</h2>
            
        </div>
    );
}
export default AdminHomepage;