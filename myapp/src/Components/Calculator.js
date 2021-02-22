import React from 'react';
import styles from './Calculator.css'

class Calculator extends React.Component {
    constructor(props) {
        super(props)

        this.state = {
            due: '',
            paid: '',
            denominations: {
                "100": 0,
                "50": 0,
                "20": 0,
                "10": 0,
                "5": 0,
                "1": 0,
                "0.5": 0,
                "0.25": 0,
                "0.1": 0,
                "0.05": 0,
                "0.01": 0,
            }
        }
        let loading = false;
        this.onChange = this.onChange.bind(this);
        this.calculate = this.calculate.bind(this);
    }

    onChange(e) {
        this.setState({ [e.target.name]: e.target.value });
    }

    getDenominations() {
        return Object.entries(this.state.denominations).filter(([name, count], i) => count > 0).map(([name, count], i) => (
            <li className="font-bold text-2xl border border-gray-200 p-2 rounded m-2">${name} x {count} </li>
        ));
    }

    async calculate() {
        let response = null;
        try {
            response = await fetch(`http://localhost:2000/?total=${this.state.due}&paid=${this.state.paid}`)
            .then(res => {
                if (res.ok) return res.json()
            })
        } catch(e) {
            response = {'error': e}
        }
        this.setState({denominations: response})
        return response
    }

    render() {
        return (
            <div className="calculator bg-white shadow-md p-3 rounded flex flex-wrap">
                <div className="m-auto">
                    <h1 className="text-5xl mb-5 p-2">EZ Cashier</h1>
                    <input onChange={this.onChange} value={this.state.due} name="due" type="number" min="0.01" step="0.01"  className="w-1/3 p-3 mx-2 rounded border border-gray-200 font-bold" placeholder="Amount Due"></input>
                    <input onChange={this.onChange} value={this.state.paid} name="paid" type="number" min="0.01" step="0.01" className="w-1/3 p-3 mx-2 rounded border border-gray-200 font-bold" placeholder="Amount Given"></input>
                    <button onClick={this.calculate} className="w-fullbtn bg-green-400 hover:bg-green-500 p-3 rounded text-white">Calculate</button>
                </div>
                <h1 className="w-full text-3xl font-bold p-3 text-gray-700">Change Required</h1>
                <ul className="mx-auto">
                    {this.getDenominations()}
                </ul>
            </div>
        )
    }
}

export default Calculator;