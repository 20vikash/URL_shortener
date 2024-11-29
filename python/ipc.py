import os
from url_shortener import URLShortener

fifo_input = '../my_pipe'
fifo_output = '../my_response_pipe'

real_input = '../real_input_pipe'
real_output = '../real_output_pipe'

for fifo in [fifo_input, fifo_output, real_input, real_output]:
    if not os.path.exists(fifo):
        os.mkfifo(fifo)

us = URLShortener()

while True:
    with open(fifo_input, 'r') as pipe:
        data = pipe.read()
        
        if data and "rubbish" not in data:
            print(f"Received URL for shortening: {data.strip()}")
            shortened_url = us.shorten(data.strip())
            
            with open(fifo_output, 'w') as response_pipe:
                response_pipe.write(str(shortened_url))

    with open(real_input, 'r') as real_pipe:
        data = real_pipe.read()

        if data and data.isnumeric():
            real_url = us.get_real_url(data)
            
            with open(real_output, 'w') as real_response_pipe:
                real_response_pipe.write(str(real_url))
