import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';

var myStorage = window.localStorage;

localStorage.setItem('BackendURL', 'http://localhost:80/php/public');
localStorage.setItem('FrontendURL', 'http://localhost:3000');

ReactDOM.render(
  <React.StrictMode>
    <App />
  </React.StrictMode>,
  document.getElementById('root')
);

