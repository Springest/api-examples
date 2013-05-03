require 'rubygems'
require 'open-uri'
require 'nokogiri'

def get_trainings(base, page_size = 10, offset = 0)
  File.open('trainings.xml', 'w') do |f|
    f.write('<?xml version="1.0" encoding="UTF-8"?><trainings>')

    begin
      url = "#{base}&size=#{page_size}&offset=#{offset}"
      puts "Opening #{url}"
      doc = Nokogiri::XML(open(url))
      total = doc.css('meta results').text.to_i

      doc.css('training').each do |training|
        f.write(training.to_s << "\n")
      end

      offset += page_size
    end while offset < total

    f.write('</trainings>')
  end
  puts 'Finished crawling. Data written to trainings.xml'
end

get_trainings 'http://api.springest.nl/trainings.xml?query=testen&api_key=YOUR_API_KEY'