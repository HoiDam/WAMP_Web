import React, { Component } from 'react';
import { Link } from 'react-router-dom';

import Box from '@material-ui/core/Box';
import Button from '@material-ui/core/Button';
import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';
import Container from '@material-ui/core/Container';
import { withStyles } from '@material-ui/core/styles';
import TextField from '@material-ui/core/TextField';
import FormLabel from '@material-ui/core/FormLabel';

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
      width: '150%', // Fix IE 11 issue.
      marginTop: theme.spacing(3),
    },
    submit: {
      margin: theme.spacing(3, 0, 2),
      height : '100%'
    },
  });

  
class Select extends Component {
    constructor(props) {
        super(props);
        this.state={
            questions:[]
          }
        this.handleOnClick = this.handleOnClick.bind(this);
        this.handleOnDelete = this.handleOnDelete.bind(this);

      }
    
    handleOnClick=(e)=>{
        let temp = {}
        this.setState({questions:[...this.state.questions,temp]})
        // console.log(this.state.questions)
    }

    handleOnChange=(e,index)=>{
        this.state.questions[index][e.target.id]=e.target.value
        this.setState({questions:this.state.questions})
    }

    handleOnDelete=(index)=>{
        this.state.questions.splice(index,1)
        this.setState({questions:this.state.questions})
        // console.log(this.state.questions)
    }
    
    handleOnSubmit=(e)=>{
        e.preventDefault();
        let max_player = e.target[0].value
        let question_set = this.state.questions
        console.log(question_set)
    }


    render(){
        const {classes} = this.props;
        return (
            
        <Container component="main" >
            <div className={classes.paper}>
            <Box mb={8}>
                <Typography component="h1" variant="h3">
                👁️‍🗨️ Quizoo 👁️‍🗨️ 
                </Typography>
            </Box>
            </div>
                
                <form onSubmit={this.handleOnSubmit}>
                    <Grid container direction="row" spacing="2" >  
                        <Grid item xs={12}>
                            <TextField
                            variant="standard"
                            required
                            fullWidth
                            autoFocus
                            id="max_player" 
                            label="Maximum Player"
                            name="max_player"
                            /> 
                        </Grid>
                        <Grid item xs={12}>
                        {
                            this.state.questions.map((question,index)=>{
                                return(
                                    <div key={index}>
                                        <Box mb={2}>
                                            <Grid container direction="row" spacing="2">
                                                <Grid item xs={12}>
                                                    <FormLabel component="legend" >Question Set {index+1}</FormLabel>
                                                </Grid>
                                                <Grid item xs={9}>
                                                    <TextField
                                                    variant="outlined"
                                                    required
                                                    fullWidth
                                                    value={question["question"]}
                                                    id="question" 
                                                    label="Question"
                                                    name="question"
                                                    onChange={(e)=>{this.handleOnChange(e,index)}}
                                                    /> 
                                                </Grid>
                                                <Grid item xs={3}>
                                                    <Button
                                                    variant="contained"
                                                    color="secondary"
                                                    size = "large"
                                                    fullWidth
                                                    className={classes.button}
                                                    onClick={()=>{this.handleOnDelete(index)}}
                                                    >
                                                    Delete Set
                                                    </Button>
                                                </Grid>
                                                <Grid item xs={3}>
                                                    <TextField
                                                    variant="outlined"
                                                    required
                                                    fullWidth
                                                    value={question["correct_answer"]}
                                                    id="correct_answer" 
                                                    label="Correct Answer"
                                                    name="correct_answer"
                                                    onChange={(e)=>{this.handleOnChange(e,index)}}
                                                    autoFocus
                                                    /> 
                                                </Grid>
                                                <Grid item xs={3} >
                                                    <TextField
                                                    variant="outlined"
                                                    required
                                                    fullWidth
                                                    value={question["choice2"]}
                                                    id="choice2" 
                                                    label="Choice 2"
                                                    name="choice2"
                                                    onChange={(e)=>{this.handleOnChange(e,index)}}
                                                    /> 
                                                </Grid>
                                                <Grid item xs={3}>
                                                    <TextField
                                                    variant="outlined"
                                                    required
                                                    fullWidth
                                                    value={question["choice3"]}
                                                    id="choice3" 
                                                    label="Choice 3"
                                                    name="choice3"
                                                    onChange={(e)=>{this.handleOnChange(e,index)}}
                                                    /> 
                                                </Grid>
                                                <Grid item xs={3} >
                                                    <TextField
                                                    variant="outlined"
                                                    required
                                                    fullWidth
                                                    value={question["choice4"]}
                                                    id="choice4" 
                                                    label="Choice 4"
                                                    name="choice4"
                                                    onChange={(e)=>{this.handleOnChange(e,index)}}
                                                    /> 
                                        </Grid>
                                            </Grid>
                                        </Box>
                                    </div>
                                )
                            })
                        }
                        </Grid>
                        <Grid item xs={12} >
                            <Button
                            variant="outlined"
                            color="primary"
                            size = "large"
                            fullWidth
                            className={classes.button}
                            onClick={(e)=>{this.handleOnClick(e)}}
                            >
                                Add Question
                            </Button>
                        </Grid>
                    </Grid>
                    <Box mt={8}>
                        <Button
                        type="submit"
                        variant="contained"
                        color="primary"
                        size = "large"
                        fullWidth
                        className={classes.button}
                        >
                            Start ❗
                        </Button>
                    </Box>
                </form>
                
            <Box mt={20}>
            </Box>
        </Container>
        )
    }
}

export default (withStyles(useStyles, { withTheme: true })(Select));