import React, {
  Component
} from 'react';

export default class EntryRequestControl extends Component {
  constructor(props) {
    super(props)
    this.state = {
      option: '',
    }

    this.onClick = this.onClick.bind(this)
  }

  onClick(option) {
    this.setState({
      option
    })
    this.props.onClick(option)
  }

  render() {
    const options = this.props.options
    return (
      <div className='d-flex flex-wrap justify-content-sm-around'>
        {
          options && options.map(option => (
            <button
              type='button'
              className={'btn btn-lg btn-outline-primary flex-fill '
                + (this.state.option === option ? ' active' : '')}
              key={option}
              onClick={() => this.onClick(option)}
              style={{ margin: '10px' }}
            >
              Get '{option}'
            </button>
          ))
        }
      </div>
    )
  }
}
