import React, { Component } from 'react';

import Avatar from '@material-ui/core/Avatar';
import Button from '@material-ui/core/Button';
import TextField from '@material-ui/core/TextField';
import Grid from '@material-ui/core/Grid';
import Box from '@material-ui/core/Box';
import Typography from '@material-ui/core/Typography';
import Container from '@material-ui/core/Container';
import { withStyles } from '@material-ui/core/styles';

import setCookie from '../utils/cookies.js'
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
      width: '150%', 
      marginTop: theme.spacing(3),
    },
    submit: {
      margin: theme.spacing(3, 0, 2),
      minHeight:'80px'
    },
  });

  
class Hosting extends Component {
    constructor(props) {
        super(props);
        this.state={
            current_question:1,
            last_question:5,
            end:false
          }
      }
    
    handleNext = ()=>{
        this.setState({current_question:this.state.current_question+1})
    }

    handleEnd = ()=>{
        this.setState({end:true})
    }

    render(){
        const {classes} = this.props;
        return (
        <Container maxWidth="sm" >

            <div className={classes.paper}>
                <Box mb={8}>
                    <Typography component="h1" variant="h3">
                    👁️‍🗨️ Quizoo 👁️‍🗨️ 
                    </Typography>
                </Box>
            </div>
                {
                    (this.state.end==false)?
                <div>
                    <Box mb={6} className={classes.paper}>
                        <Typography component="h1" variant="h4">
                        Current Question : {this.state.current_question}
                        </Typography>
                    </Box>
                    
                        
                    <Grid container direction="row" spacing="1" height="300">
                        <Grid item sm={6} height="200px">
                        {
                            
                            (this.state.current_question!=this.state.last_question)?
                                
                                    <Button
                                        fullWidth
                                        variant="contained"
                                        color="primary"
                                        className={classes.submit}
                                        onClick={this.handleNext}
                                    >
                                        <Typography component="h1" variant="h5">
                                            Next 🢂
                                        </Typography>
                                    </Button>
                                
                                :
                                <div></div>
                        
                        }
                        </Grid>
                        <Grid item sm={6} height="200px">
                            <Button
                                fullWidth
                                variant="contained"
                                color="secondary"
                                className={classes.submit}
                                onClick={this.handleEnd}
                            >
                                <Typography component="h1" variant="h5">
                                    End ◼
                                </Typography>
                            </Button>
                        </Grid>
                    </Grid>
                </div>
                :
                <Grid>
                    <Box>
                        <Typography component="h1" variant="h4">
                        Thanks for playing
                        </Typography>

                    </Box>
                    <Box>
                        <Button
                        fullWidth
                        variant="contained"
                        color="primary"
                        className={classes.submit}>
                        <Typography component="h1" variant="h5">
                                    Back to menu
                        </Typography>
                        </Button>
                    </Box>
                </Grid>
                }
            
            <Box mt={20}>
            </Box>
            </Container>
        )
    }
}

export default (withStyles(useStyles, { withTheme: true })(Hosting));