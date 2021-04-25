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

import setCookie from '../utils/cookies.js'
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

  
class Gaming extends Component {
    constructor(props) {
        super(props);
        this.state={
            question:"Are Ya Gae?",
            correct_answer:1,
            choices:["1","2","3","4"],
            end:false
          }
      }
    handleChoose = (e,index)=>{
        let chosen = index+1
        console.log(chosen)

    }

    render(){
        const {classes} = this.props;
        return (
        <div>
            <Container component="main" maxWidth="sm" >
                <div className={classes.paper}>
                <Box mb={4}>
                    <Typography component="h1" variant="h3">
                    👁️‍🗨️ Quizoo 👁️‍🗨️ 
                    </Typography>
                    
                </Box>
                
                {
                        (this.state.end==false)?
                    <div>
                        {
                            (this.state.correct_answer==0)?
                                <div>
                                    <Typography component="h1" variant="h5" align="center">
                                    Please Wait ... <CircularProgress size={20} />
                                    </Typography>
                                </div>
                            :
                            <Grid>
                                <Box mb={4}>
                                    <Typography  variant="h4">
                                    Question : {this.state.question}
                                    </Typography>
                                </Box>
                                <Grid container direction="row" spacing="3">
                                    {
                                    this.state.choices.map((choice,index)=>{
                                        return(
                                    <Grid item sm={6}>
                                        <Button
                                        fullWidth
                                        variant="outlined"
                                        value={index} 
                                        className={classes.submit}
                                        onClick={(e)=>{this.handleChoose(e,index)}}>
                                        <Typography  variant="body1">
                                            {choice}
                                        </Typography>
                                        </Button>
                                    </Grid>
                                        )
                                    })
                                    }

                                </Grid>
                            </Grid>
                        }
                    </div>

                    :<div>
                        Scoreboard
                    </div>
                }
                </div>
            </Container>
        </div>
        )
    }
}

export default (withStyles(useStyles, { withTheme: true })(Gaming));