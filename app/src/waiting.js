import React, { Component } from 'react';
import { Link } from 'react-router-dom';

import Box from '@material-ui/core/Box';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';
import ButtonGroup from '@material-ui/core/ButtonGroup';
import Typography from '@material-ui/core/Typography';
import Container from '@material-ui/core/Container';
import { withStyles } from '@material-ui/core/styles';
import TextField from '@material-ui/core/TextField';
import CircularProgress from '@material-ui/core/CircularProgress';

import setCookie from './utils/cookies.js'
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
            inv_code:"XAMPP",
            identity:"host",
            players:["gay","gay","gay","gay","gay","gay","gay","gay"]
          }
      }

    render(){
        const {classes} = this.props;
        return (
            
        <Container component="main" maxWidth="sm" >
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
                    type="submit"
                    fullWidth
                    variant="contained"
                    color="primary"
                    className={classes.submit}
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