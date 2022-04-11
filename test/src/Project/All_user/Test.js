import React from 'react';
import { useState, useEffect } from 'react';
import axios from 'axios';

const Test = () =>{
    const initialValues = {name:'', gender:"", userTypes_id:"", email:"", address:"", username:"", password:"", confirmPassword:""};
    const [formValues, setFormValues] = useState(initialValues);
    const [formErrors, setFormErrors] = useState({});
    const [isSubmitted, setIsSubmitted] = useState(false);
    const [successMsg, setSuccessMsg] = useState("");
    const [errorMsg, setErrorMsg] = useState("");


    const hStyle = { color: 'red' };
    const sStyle = { color: 'green' };


    const handleChange = (e) => {
        const {name, value} = e.target;
        setFormValues({...formValues, [name]:value});
        //console.log(formValues);
    };

    const handleSubmit = (e) =>{
        e.preventDefault();
        setFormErrors(validate(formValues));
        setIsSubmitted(true);
        
    };

    useEffect(() => {
        //console.log(formErrors);
        if (Object.keys(formErrors).length === 0 && isSubmitted){
            axios.post("http://127.0.0.1:8000/api/register", formValues).then((resp)=>{   
            setSuccessMsg(resp.data.successMsg);  
            setErrorMsg(resp.data.errorMsg);        
        },(err)=>{

        });
        }
    }, [formErrors, isSubmitted]);

    const validate = (values) =>{
        const errors = {}
        const regexName = /^[A-Z a-z.]+$/;
        const regexEmail = /^[a-zA-Z0-9]+@(?:[a-zA-Z0-9]+\.)+[A-Za-z]+$/;

        if (!values.name){
            errors.name = "Name is required";
        }else if (!regexName.test(values.name)){
            errors.name = "Name format is invalid";
        }else if (values.name.length > 50){
            errors.name = "Name is too long";
        }

        if (!values.gender){
            errors.gender = "Gender is required";
        }

        if (!values.userTypes_id){
            errors.userTypes_id = "User type is required";
        }

        if (!values.email){
            errors.email = "Email is required";
        }else if (!regexEmail.test(values.email)){
            errors.email = "Please enter a valid email";
        }

        if (!values.address){
            errors.address = "Address is required";
        }

        if (!values.username){
            errors.username = "Username is required";
        }else if ( values.username.length < 5){
            errors.username = "Username can be minimum 5 characters";
        }else if ( values.username.length >= 20){
            errors.username = "Username can be maximum 20 characters";
        }

        if (!values.password){
            errors.password = "Password is required";
        }else if ( values.password.length < 4){
            errors.password = "Password can be minimum 4 characters";
        }else if ( values.password.length >= 50){
            errors.username = "Password can be maximum 50 characters";
        }

        if (!values.confirmPassword){
            errors.confirmPassword = "Confirm password is required";
        }else if (values.confirmPassword != values.password){
            errors.confirmPassword = "Password and confirm password does not match";
        }
        return errors;
    };
    return(
        <html>
            <head>
                <meta charset="UTF-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
                <title>Sign Up Form by Colorlib</title>

                <link rel="stylesheet" href="regTemp/fonts/material-icon/css/material-design-iconic-font.min.css"/>

                <link rel="stylesheet" href="regTemp/css/style.css"/>
            </head>
            <body>
                <div class="main">
                    <div class="container">
                        <div class="signup-content">
                            
                            <div class="signup-form">
                                <form onSubmit={handleSubmit} class="register-form" id="register-form">
                                    <h2>Registration</h2>
                                    <div class="form-group">
                                        <label for="address">Name :</label>
                                        <input type="text" placeholder="Enter name" name="name" value={formValues.name} onChange={handleChange}/><br/> 
                                    </div>
                                    <p style={hStyle}>{formErrors.name}</p>
                                    <div class="form-radio" value={formValues.gender} onClick={handleChange}>
                                        <label for="gender" class="radio-label">Gender :</label>
                                        <div class="form-radio-item">
                                            <input type="radio" name="gender" id="male"/>
                                            <label for="male">Male</label>
                                            <span class="check"></span>
                                        </div>
                                        <div class="form-radio-item">
                                            <input type="radio" name="gender" id="female"/>
                                            <label for="female">Female</label>
                                            <span class="check"></span>
                                        </div>
                                        <div class="form-radio-item">
                                            <input type="radio" name="gender" id="other"/>
                                            <label for="other">Other</label>
                                            <span class="check"></span>
                                        </div>
                                    </div>
                                    <p style={hStyle}>{formErrors.gender}</p>
                                    <div class="form-group">
                                    <label for="userTypes_id">User type :</label>
                                        <div class="form-select">
                                            <select name="userTypes_id" id="userTypes_id" value={formValues.userTypes_id} onChange={handleChange}>
                                                <option value=""></option>
                                                <option value="3">patient</option>
                                            </select>
                                        <span class="select-icon"><i class="zmdi zmdi-chevron-down"></i></span>
                                        </div>
                                        <p style={hStyle}>{formErrors.userTypes_id}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="birth_date">Email :</label>
                                        <input type="text" placeholder="Enter Email" name="email" value={formValues.email} onChange={handleChange}/><br/>
                                        <p style={hStyle}>{formErrors.email}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="pincode">Address :</label>
                                        <input type="text" placeholder="Enter address" name="address" value={formValues.address} onChange={handleChange}/><br/>
                                        <p style={hStyle}>{formErrors.address}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="pincode">Username :</label>
                                        <input type="text" placeholder="Enter Username" name="username" value={formValues.username} onChange={handleChange}/><br/>
                                        <p style={hStyle}>{formErrors.username}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="pincode">Password :</label>
                                        <input type="password" placeholder="Enter Password" name="password" value={formValues.password} onChange={handleChange}/><br/>
                                        <p style={hStyle}>{formErrors.password}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="pincode">Confirm password :</label>
                                        <input type="password" placeholder="Confirm Password" name="confirmPassword" value={formValues.confirmPassword} onChange={handleChange}/><br/>
                                        <p style={hStyle}>{formErrors.confirmPassword}</p>
                                    </div>
                                    <h3 style={sStyle}>{successMsg}</h3>
                                    <h3 style={hStyle}>{errorMsg}</h3>
                                    <div class="form-submit">
                                        <input type="submit" value="Submit" class="submit" name="submit" id="submit" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="regTemp/vendor/jquery/jquery.min.js"></script>
                <script src="regTemp/js/main.js"></script>
            </body>
        </html>
    );
}
export default Test;