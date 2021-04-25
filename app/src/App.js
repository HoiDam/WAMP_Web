import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router,Switch ,Route } from 'react-router-dom'

import Login from './login.js'
import Select from './select.js'
import Create from './host/create.js'
import Waiting from './waiting.js'
import Error from './error.js'
import Hosting from './host/hosting.js';
import Gaming from './player/gaming.js';


function App() {
  return (
    <Router  >
     {/* <Router > */}
      <Switch>
        <Route exact path="/" component={Login} />
        <Route exact path="/select" component={Select} />
        <Route exact path="/create" component={Create} />
        <Route exact path="/waiting" component={Waiting} />
        <Route exact path="/hosting" component={Hosting} />
        <Route exact path="/gaming" component={Gaming} />
        <Route >
          <Error/>
        </Route>
       
      </Switch>
    </Router>
  );
}

export default App;
