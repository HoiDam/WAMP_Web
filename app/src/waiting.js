import React, { Component } from 'react';
import { Redirect } from 'react-router-dom';

import Box from '@material-ui/core/Box';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';
import ButtonGroup from '@material-ui/core/ButtonGroup';
import Typography from '@material-ui/core/Typography';
import Container from '@material-ui/core/Container';
import { withStyles } from '@material-ui/core/styles';
import TextField from '@material-ui/core/TextField';
import CircularProgress from '@material-ui/core/CircularProgress';

import {setCookie,getCookie} from './utils/cookies.js'
const useStyles = theme => ({
    paper: {
      marginTop: theme.spacing(6),
      display: 'flex',
      flexDirection: 'column',
      alignItems: 'center',
    },
    form: {
      width: '150%', // Fix IE 11 issue.
      marginTop: theme.spacing(3),
    },
    submit: {
      margin: theme.spacing(3, 0, 2),
    },
  });

  
class Waiting extends Component {
    constructor(props) {
        super(props);
        this.state={
            room_id:getCookie("room_id"),
            inv_code:getCookie("inv_code"),
            identity:getCookie("role"),
            players:[],
            hostStarted:false,
            playStarted:false
          }
      }
    componentDidMount(){
      this.interval = setInterval(() => this.checkWaiting(), 1000);
      if (this.state.identity=="player"){
        this.interval = setInterval(() => this.checkStatus(), 1000);
      }
    }
    checkWaiting = async()=>{
      const requestOptions={
        method: "POST",
        headers: {'Content-Type': 'application/json'},
        body:JSON.stringify({"room_id":this.state.room_id})
      }
      const encoded_players = await fetch(localStorage.getItem("BackendURL")+"/user/obtain", requestOptions)
        .then(res => res.json())
        .then(data=> {
        if (data["status"]=="success")
          return data["msg"] 
        })
        .catch(error => console.log(error))
      
      var players = []
      for (const player in encoded_players){
        players.push(encoded_players[player]["name"])
      }
      if (players!=this.state.players){
        this.setState({players:players})
      }
    }
    checkStatus = async()=>{
      const requestOptions={
        method: "POST",
        headers: {'Content-Type': 'application/json'},
        body:JSON.stringify({"room_id":this.state.room_id})
      }
      await fetch(localStorage.getItem("BackendURL")+"/room/status", requestOptions)
      .then(res => res.json())
      .then(data=> {
      if (data["status"]=="success" )
        if (data["msg"][0]["status"]=="started"){
          this.setState({playStarted:true})
        } 
      })
      .catch(error => console.log(error))
    }

    handleStart =async ()=>{
      let room_id = this.state.room_id
      const requestOptions={
        method: "POST",
        headers: {'Content-Type': 'application/json'},
        body:JSON.stringify({"room_id":room_id})
      }
      await fetch(localStorage.getItem("BackendURL")+"/room/start", requestOptions)
        .then(res => res.json())
        .then(data=> {
        if (data["status"]=="success")
        this.setState({hostStarted:true})
        })
        .catch(error => console.log(error))
    }

    render(){
        const {classes} = this.props;
        return (
            
        <Container component="main" maxWidth="sm" >
            {
              (this.state.hostStarted==false)?
              <div></div>
              :
              <Redirect to='/hosting'></Redirect>

            }
            {
              (this.state.playStarted==false)?
              <div></div>
              :
              <Redirect to='/gaming'></Redirect>

            }
            <div className={classes.paper}>
              <Box mb={4}>
                  <Typography component="h1" variant="h3">
                  👁️‍🗨️ Quizoo 👁️‍🗨️ 
                  </Typography>
                  
              </Box>
              <Box mb={4}>
                  <Typography  variant="h4">
                  Waiting Room ✨
                  </Typography>
              </Box>
            </div>
            <Box mb={2}>
              <Grid container direction="row" spacing="1">
                <Grid item sm={6}>
                  <TextField
                    variant="outlined"
                    fullWidth
                    disabled
                    id="identity"
                    label="Role"
                    name="identity"
                    value={this.state.identity}
                  />
                </Grid>
                <Grid item sm={6}>
                  <TextField
                    variant="outlined"
                    fullWidth
                    disabled
                    id="inv_code"
                    label="Invitation Code"
                    name="inv_code"
                    value={this.state.inv_code}
                  />
                </Grid>
              </Grid>
            </Box>
            <Box border={1} minHeight={200}>
              <Grid container direction="row" spacing="3">
                <Grid item sm={12}>
                  <Typography component="h1" variant="h5" align="center">
                  Joined Players :
                  </Typography>
                </Grid>
                {
                  this.state.players.map((player,index)=>{
                      return(
                        <Grid item sm={3}>
                          <Typography component="h1" variant="body1" align="center">
                          {player}
                          </Typography>
                        </Grid>
                      )
                  })
                }
              </Grid>
            </Box>
            <Box mt={20}>
              {
                (this.state.identity=="host")?
                <Button
                    fullWidth
                    variant="contained"
                    color="primary"
                    className={classes.submit}
                    onClick={this.handleStart}
                >
                    Start 
                </Button>
                :
                <div>
                  <Typography component="h1" variant="h5" align="center">
                  Please Wait ... <CircularProgress size={20} />
                  </Typography>
                </div>
              }
            </Box>
            </Container>
        )
    }
}

export default (withStyles(useStyles, { withTheme: true })(Waiting));