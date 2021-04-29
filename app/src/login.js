import React, { Component } from 'react';
import { Redirect } from 'react-router-dom';

import Button from '@material-ui/core/Button';
import TextField from '@material-ui/core/TextField';
import Grid from '@material-ui/core/Grid';
import Box from '@material-ui/core/Box';
import Typography from '@material-ui/core/Typography';
import Container from '@material-ui/core/Container';
import { withStyles } from '@material-ui/core/styles';

import {setCookie} from './utils/cookies.js'
const useStyles = theme => ({
    paper: {
      marginTop: theme.spacing(6),
      display: 'flex',
      flexDirection: 'column',
      alignItems: 'center',
    },
    avatar: {
      margin: theme.spacing(1),
      backgroundColor: theme.palette.primary.main,
    },
    form: {
      width: '150%', // Fix IE 11 issue.
      marginTop: theme.spacing(3),
    },
    submit: {
      margin: theme.spacing(3, 0, 2),
    },
  });

  
class Login extends Component {
    constructor(props) {
        super(props);
        this.state={
            received : false
          }
    }
    
    onHandleSubmit = async(e)=>{
      e.preventDefault()
      let username = e.target[0].value

      const requestOptions={
        method: "POST",
        headers: {'Content-Type': 'application/json'},
        body:JSON.stringify({"username":username})
      };
      // console.log(localStorage.getItem("BackendURL")+"/user/create")
      const user_id = await fetch(localStorage.getItem("BackendURL")+"/user/create", requestOptions)
        .then(res => res.json())
        .then(data=> {console.log(data) ; 
        if (data["status"]=="success")
          return data["msg"]
        })
        .catch(error => console.log(error))
      setCookie('user_id', user_id, 2);
      this.setState({received:true})
    }

    
    render(){
        const {classes} = this.props;
        return (
        <Container component="main" maxWidth="xs" >
            {
                (this.state.received==false)?
                <div></div>
                :
                <Redirect to='/select'></Redirect>

            }
            <div className={classes.paper}>
                <Box mb={8}>
                <Typography component="h1" variant="h3">
                👁️‍🗨️ Quizoo 👁️‍🗨️ 
                </Typography>
                </Box>
                <Typography component="h1" variant="h5">
                Enter User Name 💬
                </Typography>
                
                <form className={classes.form} onSubmit={this.onHandleSubmit}>
                <Grid container spacing={2}>
                    <Grid item xs={12}>
                    <TextField
                        variant="outlined"
                        required
                        fullWidth
                        id="username"
                        label="User Name"
                        name="username"
                        autoComplete="username"
                    />
                    </Grid>
                </Grid>
                <Button
                    type="submit"
                    fullWidth
                    variant="contained"
                    color="secondary"
                    className={classes.submit}
                >
                    Play !
                </Button>
                </form>
            </div>
            <Box mt={20}>
            </Box>
            </Container>
        )
    }
}

export default (withStyles(useStyles, { withTheme: true })(Login));