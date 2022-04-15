import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import reportWebVitals from './reportWebVitals';
import Homepage from './Project/All_user/Homepage';
import {BrowserRouter as Router, Route, Switch} from 'react-router-dom';
import Login from './Project/All_user/Login';
import Logout from './Project/All_user/Logout';
import Register from './Project/All_user/Register';
import AdminHomepage from './Project/Users/Admin/AdminHomepage';
import axios from 'axios';

var token = null;
if (localStorage.getItem('authToken')){
  token = localStorage.getItem('authToken');
}
axios.defaults.headers.common['Authorization'] = token;

ReactDOM.render(
  <React.StrictMode>
    <Router>
      <Switch>
        <Route exact path="/homepage"> <Homepage/> </Route>
        <Route exact path="/login"> <Login/> </Route>
        <Route exact path="/logout"> <Logout/> </Route>
        <Route exact path="/register"> <Register/> </Route>
        <Route exact path="/adminHomepage"> <AdminHomepage/> </Route>
      </Switch>
    </Router>
  </React.StrictMode>,
  document.getElementById('root')
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
