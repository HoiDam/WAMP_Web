import React from 'react';
import { Doughnut ,defaults} from 'react-chartjs-2';

const DoughnutChart = (props) => 
{
    console.log(props)

    const data = {
        labels: ['Wrong', 'Correct'],
        datasets: [
          {
            label: '# of Votes',
            data: [props.wrong_count, props.correct_count],
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
            ],
            borderWidth: 1,
          },
        ],
      };

    return(
    
        <>
            <div style={{ position: "relative", margin: "auto", width: "50vw" }}>
                <Doughnut data={data} />
            </div>
        </>
);
}
export default DoughnutChart;