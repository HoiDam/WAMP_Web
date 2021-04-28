import React, { Component } from 'react';
import { Link } from 'react-router-dom';

import Box from '@material-ui/core/Box';
import Button from '@material-ui/core/Button';
import ButtonGroup from '@material-ui/core/ButtonGroup';
import Typography from '@material-ui/core/Typography';
import Container from '@material-ui/core/Container';
import { withStyles } from '@material-ui/core/styles';
import TextField from '@material-ui/core/TextField';

import setCookie from './utils/cookies.js'
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

  
class Select extends Component {
    constructor(props) {
        super(props);
        this.state={
            inv_code:"",
            emptyness:true
          }
      }

    handleOnChange=(e)=>{
      if (e.target.value.length==0){
        this.setState({inv_code:e.target.value,emptyness:true})
      }else{
        this.setState({inv_code:e.target.value,emptyness:false})
      }
    }
    handleOnJoin = (e) =>{
      let inv_code = this.state.inv_code
      console.log(inv_code)
    }
    render(){
        const {classes} = this.props;
        return (
            
        <Container component="main" maxWidth="xs" >
            <div className={classes.paper}>
            <Box mb={8}>
                <Typography component="h1" variant="h3">
                👁️‍🗨️ Quizoo 👁️‍🗨️ 
                </Typography>
                
            </Box>
            <TextField
                variant="outlined"
                fullWidth
                id="inv_code"
                label="Invitation Code"
                name="inv_code"
                autoComplete="inv_code"
                onChange={this.handleOnChange}
            />
            <Box display="flex">
                <ButtonGroup size="large" color="secondary" orientation="horizontal" variant="text" aria-label="outlined secondary button group " className={classes.submit}>
                  <Button disabled ={!this.state.emptyness} component={Link} to="/create" >Create room</Button>
                  <Button disabled ={this.state.emptyness} onClick={this.handleOnJoin}> Join room</Button>
                </ButtonGroup>
                
            </Box>
            </div>
            
            
            <Box mt={20}>
            </Box>
            </Container>
        )
    }
}

export default (withStyles(useStyles, { withTheme: true })(Select));