import React, { Component } from 'react';
import { Link } from 'react-router-dom';

import Box from '@material-ui/core/Box';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';
import Typography from '@material-ui/core/Typography';
import Container from '@material-ui/core/Container';
import { withStyles } from '@material-ui/core/styles';
import CircularProgress from '@material-ui/core/CircularProgress';
import Modal from '@material-ui/core/Modal';
import Backdrop from '@material-ui/core/Backdrop';
import Fade from '@material-ui/core/Fade';
import LinearProgress from '@material-ui/core/LinearProgress';

import DoughnutChart from './scoreboard.js'

import setCookie, { getCookie } from '../utils/cookies.js'
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
      height:"100%",
      minWidth:"100%"
    },
    typo:{
        fontWeight: 600
    },
    modal: {
        display: 'flex',
        alignItems: 'center',
        flexDirection: 'column',
        justifyContent: 'center',
    },
    modalpaper: {
        backgroundColor: theme.palette.background.paper,
        boxShadow: theme.shadows[5],
        padding: theme.spacing(2, 4, 3),
        height:"200px"
      },
    bar: {
    height: 10,
    borderRadius: 5,
    },
  });

  
class Gaming extends Component {
    constructor(props) {
        super(props);
        this.state={
            question:"",
            correct_answer:-1,
            choices:[],
            end:false, //
            correctness:false,
            modalOpen:false,
            correct_count:0,  
            wrong_count:0,
            answered:false,
            current_question:0,
            total_question:1,
            room_id:getCookie("room_id")
        }
    }

    componentDidMount(){
        if (this.state.end==false){
        this.interval = setInterval(() => 
        this.checkStatus(), 1000);
        }
    }

    getQuestion = async(question_no)=>{
        const requestOptions={
            method: "POST",
            headers: {'Content-Type': 'application/json'},
            body:JSON.stringify({"room_id":this.state.room_id,"question_no":question_no})
        }
        await fetch(localStorage.getItem("BackendURL")+"/question/get", requestOptions)
        .then(res => res.json())
        .then(data=> {
        if (data["status"]=="success" ){
            let received = data["msg"][0]
            console.log(received)
            let r_choices = []
            r_choices.push(received["c1"],received["c2"],received["c3"],received["c4"])

            this.setState({
                correct_answer:parseInt(received["correct_ans"])+1,
                choices:r_choices,
                question:received["question"]
            })
            console.log(this.state.choices)
        }
        })
        .catch(error => console.log(error))
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
        if (data["status"]=="success" ){
            // console.log(data["msg"])
            let current_q = parseInt(data["msg"][0]["current_q"])+1
            if (data["msg"][0]["status"]=="finished"){
                clearInterval(this.interval)
                this.setState({end:true})
                
            }
            else if (this.state.current_question != current_q){
                this.setState({
                    current_question:current_q,
                    total_question:data["msg"][0]["question_total"],
                    answered:false
                })
                this.getQuestion(current_q-1)
            }
        }
        })
        .catch(error => console.log(error))
    }

    handleChoose = (e,index)=>{
        let chosen = index+1
        console.log(chosen)
        if (chosen==this.state.correct_answer){
            this.setState({
                modalOpen:true,
                correctness:true,
                answered:true,
                correct_count:this.state.correct_count+1});
        }else {
            this.setState({
                modalOpen:true,
                correctness:false,
                answered:true,
                wrong_count:this.state.wrong_count+1});
        }
    }
    handleClose = () => {
        this.setState({modalOpen:false});
    };

    render(){
        const {classes} = this.props;
        return (
        <div>
            <Container component="main" maxWidth="md" >
                <div className={classes.paper}>
                <Box mb={4}>
                    <Typography component="h1" variant="h3">
                    👁️‍🗨️ Quizoo 👁️‍🗨️ 
                    </Typography>
                </Box>
                </div>
                {
                        (this.state.end==false)?
                    <div>
                        {
                            (this.state.correct_answer==-1)?
                                <div>
                                    <Typography component="h1" variant="h5" align="center">
                                    Please Wait ... <CircularProgress size={20} />
                                    </Typography>
                                </div>
                            :
                            <Grid>
                                <Box mb={4} className={classes.paper}>
                                    <Typography  variant="h4">
                                    {this.state.current_question}/{this.state.total_question}
                                    </Typography>
                                    
                                </Box>
                                <Box mb={4} >
                                    <LinearProgress className={classes.bar} variant="determinate" value={this.state.current_question/this.state.total_question*100}/>
                                </Box>

                                <Box mb={4} className={classes.paper}>
                                    <Typography  variant="h4">
                                    Question : {this.state.question}
                                    </Typography>
                                </Box>
                                <Grid container direction="row" spacing="3">
                                    {
                                    this.state.choices.map((choice,index)=>{
                                        return(
                                    <Grid item xs={6} >
                                        <Button
                                        fullWidth
                                        variant="outlined"
                                        value={index} 
                                        className={classes.submit}
                                        disabled={this.state.answered}
                                        onClick={(e)=>{this.handleChoose(e,index)}}>
                                        <Typography  variant="body1" className={classes.typo} >
                                            <div>{choice}</div>
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

                    :
                    <div>
                        <Box mb={4} className={classes.paper}>
                            <Typography component="h1" variant="h3">
                            Scoreboard 💯
                            </Typography>
                        </Box>
                        <DoughnutChart 
                            correct_count={this.state.correct_count}
                            wrong_count={this.state.wrong_count}
                            >

                        </DoughnutChart>
                        <Box className={classes.paper}>
                            <Button
                            fullWidth
                            variant="contained"
                            color="primary"
                            className={classes.submit}
                            component={Link} to="/" >
                            <Typography component="h1" variant="h5">
                                Back to menu
                            </Typography>
                            </Button>
                        </Box>
                    </div>
                }

                
            </Container>
            <Modal
                className={classes.modal}
                open={this.state.modalOpen}
                onClose={this.handleClose}
                closeAfterTransition
                BackdropComponent={Backdrop}
                BackdropProps={{
                timeout: 500,
                }}
            >
                <Fade in={this.state.modalOpen}>
                    <Container component="main" maxWidth="xs" >
                    <div className={classes.modalpaper}>
                        <Grid container direction="column" spacing="3" justify="center" alignItems="center">
                            <Grid item xs={12} >
                                <Typography variant="h4">
                                    {
                                        (this.state.correctness==false)?
                                        <div>WRONG</div>
                                        :
                                        <div>CORRECT</div>
                                    }
                                </Typography>
                            </Grid>
                            <Grid item xs={12}>
                            <Box mb={2}>
                                <Typography variant="h2" >
                                    {
                                        (this.state.correctness==false)?
                                        <div>❌</div>
                                        :
                                        <div>✔️</div>
                                    }
                                </Typography >
                            </Box>
                            </Grid>
                            <Grid item xs={12}>
                            <Box mb={2}>
                                <Typography variant="body1" >
                                    {
                                        (this.state.correctness==false)?
                                        <div>Correct answer :{this.state.choices[this.state.correct_answer]}</div>
                                        :
                                        <div></div>
                                    }
                                </Typography>
                            </Box>
                            </Grid>
                        </Grid>
                    </div>
                </Container>
                </Fade>
            </Modal>
        </div>
        )
    }
}

export default (withStyles(useStyles, { withTheme: true })(Gaming));