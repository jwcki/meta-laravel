import React, {
  Component
} from 'react';
import ReactDOM from 'react-dom';
import EntryList from './EntryList';
import APIService from '../services/APIService';
import EntryRequestControl from './EntryRequestControl';

export default class App extends Component {
  constructor(props) {
    super(props)
    this.state = {
      entries: [],
      loading: false,
      greeting: true,
    }

    this.onEntryRequest = this.onEntryRequest.bind(this)
  }

  onEntryRequest(option) {
    const newState = {
      loading: true,
    }
    if (this.state.greeting) {
      newState.greeting = false
    }
    this.setState(newState)

    if (this.request) {
      this.request.cancel()
    }

    this.request = APIService.getEntries(option)

    this.request.request()
      .then(response => {
        this.setState({
          entries: response.data.data,
          loading: false
        })
        this.request = null
      }).catch(e => {
      })
  }

  render() {
    const options = ['Matrix', 'Matrix Reloaded', 'Matrix​ Revolutions']
    return (
      <div className='container justify-content-center'>
        <EntryRequestControl
          options={options}
          onClick={this.onEntryRequest}
        />
        {this.state.loading || this.state.greeting ? (
          <div className='row justify-content-center'>
            <h5>{this.state.loading ? 'Loading...' : 'Please Select'}</h5>
          </div>
        ) : (
            <EntryList entries={this.state.entries} />
          )}
      </div>
    )
  }
}

ReactDOM.render(<App />, document.getElementById('app'))
